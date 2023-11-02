<?php

namespace Concrete\Package\SitePassword\Controller\SinglePage\Dashboard\System\Permissions;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

class SitePassword extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/permissions/site_password/settings');
    }
}
