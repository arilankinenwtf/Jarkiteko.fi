<?php

namespace Application\Block\EmptySpacer;

use Concrete\Core\Block\BlockController;
use Core;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController
{

    protected $btTable = "btSpacer";
    protected $btInterfaceWidth = "350";
    protected $btInterfaceHeight = "350";
    protected $btDefaultSet = 'basic';

    public function getBlockTypeName()
    {
        return t('Empty spacer');
    }

    public function getBlockTypeDescription()
    {
        return t('Empty spacer');
    }
}
