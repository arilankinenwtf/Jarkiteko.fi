<?php

namespace Concrete\Package\SitePassword;

use A3020\SitePassword\Middleware\SitePasswordMiddleware;
use Concrete\Core\Http\ServerInterface;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

final class Controller extends Package
{
    protected $pkgHandle = 'site_password';
    protected $appVersionRequired = '8.4.0';
    protected $pkgVersion = '1.0.0';
    protected $pkgAutoloaderRegistries = [
        'src/SitePassword' => '\A3020\SitePassword',
    ];

    public function getPackageName()
    {
        return t('Site Password');
    }

    public function getPackageDescription()
    {
        return t('Require users to enter a password before viewing a website.');
    }

    public function on_start()
    {
        $this->app->extend(ServerInterface::class, function(ServerInterface $server) {
            return $server->addMiddleware($this->app->make(SitePasswordMiddleware::class));
        });
    }

    public function install()
    {
        $pkg = parent::install();

        foreach ([
            '/dashboard/system/permissions/site_password' => 'Site Password',
            '/dashboard/system/permissions/site_password/settings' => 'Settings',
        ] as $path => $name) {
            $page = Page::getByPath($path);

            if (!$page || $page->isError()) {
                $single_page = Single::add($path, $pkg);
                $single_page->update([
                    'cName' => $name,
                ]);
            }
        }
    }
}
