<?php

namespace A3020\SitePassword\Middleware;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Http\Middleware\DelegateInterface;
use Concrete\Core\Http\Middleware\MiddlewareInterface;
use Concrete\Core\Permission\IPService;
use Concrete\Core\Url\Resolver\CanonicalUrlResolver;
use Concrete\Core\User\User;
use Concrete\Core\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SitePasswordMiddleware implements MiddlewareInterface, ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var \Concrete\Core\Config\Repository\Repository
     */
    private $config;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var \Concrete\Core\Permission\IPService
     */
    private $ipService;

    public function __construct(Repository $config, IPService $ipService)
    {
        $this->config = $config;
        $this->ipService = $ipService;
    }

    public function process(Request $request, DelegateInterface $frame)
    {
        if ($this->blockAccess($request)) {
            return $this->loginForm();
        }

        /** @var Response $response */
        $response = $frame->next($request);

        return $response;
    }

    /**
     * Return true if the user needs to login first.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    private function blockAccess(Request $request)
    {
        // Only show the login form if the Site Password add-on is enabled.
        if ($this->config->get('site_password::settings.enabled', true) === false) {
            return false;
        }

        // Only show the login form if a password has been configured.
        if (empty($this->getPasswordHash())) {
            return false;
        }

        // Only show the login form if user hasn't authenticated yet.
        if ($this->isAuthenticated()) {
            return false;
        }

        // Check the password if the form is submitted.
        if ($request->isMethod('post')) {
            if ($this->checkLogin($request)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the password hash from the config file.
     *
     * @return string
     */
    private function getPasswordHash()
    {
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);

        return (string)$config->get('site_password::settings.password');
    }

    /**
     * Checks whether the user is authenticated.
     *
     * @return bool
     */
    private function isAuthenticated()
    {
        /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
        $session = $this->app->make('session');
        if ($session->has('site_password.authenticated')) {
            return true;
        }

        $u = new User();
        if ($u->isRegistered()) {
            return true;
        }

        return false;
    }

    /**
     * Validate the password.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return bool
     */
    private function checkLogin(Request $request)
    {
        $token = $this->app->make('token');
        if (!$token->validate('site_password.login')) {
            $this->error = $token->getErrorMessage();

            return false;
        }

        // Deal with excessive logins from an IP
        if ($this->app->make('failed_login')->isThresholdReached()) {
            $this->app->make('failed_login')->addToDenylistForThresholdReached();
            $this->error = $this->ipService->getErrorMessage();

            return false;
        }

        if (!$this->validatePassword($request->request->get('password'))) {
            $this->error = t('Password incorrect. Please try again.');

            $this->ipService->logFailedLogin();

            return false;
        }

        /** @var \Symfony\Component\HttpFoundation\Session\Session $session */
        $session = $this->app->make('session');
        $session->set('site_password.authenticated', true);

        return true;
    }

    /**
     * Return true if password is correct.
     *
     * @param string $password
     *
     * @return bool
     */
    private function validatePassword($password)
    {
        $u = new User();

        return $this->app->make(\Concrete\Core\Encryption\PasswordHasher::class) 
            ->CheckPassword($password, $this->getPasswordHash());
    }

    /**
     * Render the login form.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function loginForm()
    {
        $view = new View('site_password/site_password_login');
        $view->setPackageHandle('site_password');

        /** @var CanonicalUrlResolver $urlResolver */
        $urlResolver = $this->app->make(CanonicalUrlResolver::class);

        $view->addScopeItems([
            'baseUrl' => $urlResolver->resolve([]),
            'form' => $this->app->make('helper/form'),
            'token' => $this->app->make('token'),
            'error' => $this->error,
        ]);

        return new Response(
            $view->render(),
            Response::HTTP_NOT_FOUND
        );
    }
}
