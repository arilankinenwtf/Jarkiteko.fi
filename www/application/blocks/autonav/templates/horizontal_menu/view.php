<?php defined('C5_EXECUTE') or die("Access Denied.");

/*
* Horizontal_menu template
* Vaakamallinen navigaatio käytettäväksi sivustoilla joilla on alasivuja
* Säädä Concretessa autom. navigaation lohkon asetuksia:
* * - Aloita automaattinen navigointi ylätasolta
* * - Alasivut Näytä kaikki.
* * - Sivutasot Näytä kaikki.
* * * - (paitsi jos näytetään vain esim. kaksi ylintä tasoa,
* * *   valitse "itse valitsemasi määrä" ja arvoksi 2)
*/

$navItems = $controller->getNavItems();
$c = Page::getCurrentPage();

foreach ($navItems as $ni) {
    $classes = array();

    if ($ni->isCurrent) {
        //class for the page currently being viewed
        $classes[] = 'nav-selected';
    }

    if ($ni->inPath) {
        //class for parent items of the page currently being viewed
        $classes[] = 'nav-path-selected';
    }

    if ($ni->hasSubmenu) {
      //class for parent items of the page currently being viewed
      $classes[] = 'has-submenu';
  }

    /*
    if ($ni->isFirst) {
        //class for the first item in each menu section (first top-level item, and first item of each dropdown sub-menu)
        $classes[] = 'nav-first';
    }
    */

    /*
    if ($ni->isLast) {
        //class for the last item in each menu section (last top-level item, and last item of each dropdown sub-menu)
        $classes[] = 'nav-last';
    }
    */

    /*
    if ($ni->hasSubmenu) {
        //class for items that have dropdown sub-menus
        $classes[] = 'nav-dropdown';
    }
    */

    /*
    if (!empty($ni->attrClass)) {
        //class that can be set by end-user via the 'nav_item_class' custom page attribute
        $classes[] = $ni->attrClass;
    }
    */

    /*
    if ($ni->isHome) {
        //home page
        $classes[] = 'nav-home';
    }
    */

    /*
    //unique class for every single menu item
    $classes[] = 'nav-item-' . $ni->cID;
    */

    //Put all classes together into one space-separated string
    $ni->classes = implode(" ", $classes);
}

if (count($navItems) > 0) {
    echo '<ul class="nav horizontal-nav">'; //opens the top-level menu

    foreach ($navItems as $ni) {
        $chevronIcon = $ni->hasSubmenu ? '<div class="subnav-icon"></div>' : '';
        echo '<li class="' . $ni->classes . '">'; //opens a nav item

        $niPageId = $ni->cID;
        if($niPageId && $niPageId > 1) {
            $niPage = Page::getByID($niPageId);
            if($niPage->getAttribute('service_nav_icon')) {
                $niPageIcon = $niPage->getAttribute('service_nav_icon')->getURL();
                $niPageIconHtml = '<img class="header-nav-submenu-icon" src="' . $niPageIcon . '">';
            } else {
                $niPageIconHtml = "";
            }
        }

        echo '<a href="' . $ni->url . '" target="' . $ni->target . '" class="' . $ni->classes . '">' . $niPageIconHtml . 
            h($ni->name) . $chevronIcon . '</a>';

        if ($ni->hasSubmenu) {
            echo '<div class="submenu-wrapper"><ul>'; //opens a dropdown sub-menu
        } else {
            echo '</li>'; //closes a nav item

            echo str_repeat('</ul></div></li>', $ni->subDepth); //closes dropdown sub-menu(s) and their top-level nav item(s)
        }
    }

    echo '</ul>'; //closes the top-level menu
} elseif (is_object($c) && $c->isEditMode()) {
    ?>
    <div class="ccm-edit-mode-disabled-item"><?=t('Empty Auto-Nav Block.')?></div>
<?php
}