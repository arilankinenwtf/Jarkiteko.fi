<?php  

namespace Concrete\Package\SitePassword\Controller\SinglePage\Dashboard\System\Permissions\SitePassword;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\User\User;

class Settings extends DashboardPageController
{
    public function view()
    {
        $config = $this->getConfig();

        $this->set('enabled', (bool) $config->get('site_password::settings.enabled', false));
        $this->set('hasPassword', !empty($config->get('site_password::settings.password')));
    }

    public function save()
     {
        if (!$this->token->validate('a3020.site_password.settings')) {
            $this->flash('error', $this->token->getErrorMessage());

            return;
        }

        $config = $this->getConfig();
        $config->save('site_password::settings.enabled', $this->request->request->has('enabled'));

        if (!empty($this->request->request->get('password'))) {
            $config->save('site_password::settings.password', $this->encrypt($this->request->request->get('password')));
        }

        $this->flash('success', t('Settings saved successfully.'));

        return Redirect::to('/dashboard/system/permissions/site_password/settings');
    }

    /**
     * @return \Concrete\Core\Config\Repository\Repository
     */
    private function getConfig()
    {
        return $this->app->make(Repository::class);
    }

    /**
     * @param string $password
     *
     * @return string
     */
    private function encrypt($password)
    {
        $u = new User();

        return $this->app->make(\Concrete\Core\Encryption\PasswordHasher::class) 
            ->HashPassword($password);
    }
}
