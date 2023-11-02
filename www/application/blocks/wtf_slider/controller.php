<?php

namespace Application\Block\WtfSlider;

use Core;
use Concrete\Core\File\File;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;
use Database;
use Concrete\Core\Editor\LinkAbstractor;
use Concrete\Core\File\Tracker\FileTrackableInterface;
use Concrete\Core\Statistics\UsageTracker\AggregateTracker;
use Less_Parser;
use Less_Tree_Rule;
use View;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController implements FileTrackableInterface
{

    protected $btTable = "btWtfSliderList";
    protected $btExportTables = array('btWtfSliderList', 'btWtfSliderItems');
    protected $btInterfaceWidth = 500;
    protected $btInterfaceHeight = 550;
    protected $btDefaultSet = 'basic';

    /**
     * @var \Concrete\Core\Statistics\UsageTracker\AggregateTracker|null
     */
    protected $tracker;

    /**
     * Instantiates the block controller.
     *
     * @param \Concrete\Core\Block\BlockType\BlockType|null $obj
     * @param \Concrete\Core\Statistics\UsageTracker\AggregateTracker|null $tracker
     */
    public function __construct($obj = null, AggregateTracker $tracker = null)
    {
        parent::__construct($obj);
        $this->tracker = $tracker;
    }

    public function getBlockTypeName()
    {
        return t('Slider');
    }

    public function getBlockTypeDescription()
    {
        return t('Slider for text and images');
    }

    public function on_start() {
        $v = View::getInstance();
        // Splide.js slider library
        // https://splidejs.com/getting-started/
        $v->addHeaderItem('<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>');
        $v->addHeaderItem('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">');
    }

    public function getSearchableContent()
    {
        $content = '';
        $db = Database::connection();
        $v = array($this->bID);
        $q = 'select * from btWtfSliderItems where bID = ?';
        $r = $db->query($q, $v);
        foreach ($r as $row) {
            $content = $row['titleText']
                . ' ' . $row['descriptionText'];
        }
        return $content;
    }

    public function getEntries()
    {
        $db = Database::get();
        $r = $db->GetAll('SELECT * from btWtfSliderItems WHERE bID = ? ORDER BY sortOrder', array($this->bID));
        $rows = [];
        $sec = $this->app->make('helper/security');
        foreach ($r as $q) {
            $q['description'] = LinkAbstractor::translateFrom($q['description']);
            $rows[] = $q;
        }
        return $rows;
    }
    
    public function view()
    {
        $rows = $this->getEntries();
        $this->set('rows', $rows);

        $rowsCount = count($rows);
        $this->set('rowsCount', $rowsCount);

    }

    public function edit()
    {
        // get rows
        $this->set('rows', $this->getEntries());
    }

    public function duplicate($newBID)
    {
        parent::duplicate($newBID);
        $db = $this->app->make(Connection::class);
        $copyFields = 'fID, titleText, descriptionText, sortOrder';
        $db->executeUpdate(
            "INSERT INTO btWtfSliderItems (bID, {$copyFields}) SELECT ?, {$copyFields} FROM btWtfSliderItems WHERE bID = ?",
            [
                $newBID,
                $this->bID
            ]
        );
    }

    public function delete()
    {
        $db = Database::get();
        $db->delete('btWtfSliderItems', ['bID' => $this->bID]);
        parent::delete();
        $this->getTracker()->forget($this);
    }

    public function save($args)
    {
        $db = $this->app->make('database')->connection();
        $db->executeQuery('DELETE FROM btWtfSliderItems WHERE bID = ?', [$this->bID]);
        parent::save($args);
        $count = isset($args['sortOrder']) ? count($args['sortOrder']) : 0;

        $i = 0;
        while ($i < $count) {
            if (isset($args['descriptionText'][$i])) {
                $args['descriptionText'][$i] = LinkAbstractor::translateTo($args['descriptionText'][$i]);
            }

            $db->executeQuery(
                'INSERT INTO btWtfSliderItems (bID, fID, titleText, descriptionText, sortOrder) values(?,?,?,?,?)',
                [
                    $this->bID,
                    (int) $args['fID'][$i],
                    $args['titleText'][$i],
                    $args['descriptionText'][$i],
                    $args['sortOrder'][$i],
                ]
            );
            ++$i;
        }
        $this->getTracker()->track($this);
    }

    public function getFileID()
    {
        return isset($this->record->fID) ? $this->record->fID : (isset($this->fID) ? $this->fID : null);
    }

    public function getFileObject()
    {
        return File::getByID($this->getFileID());
    }

    public function getUsedFiles()
    {
        return [$this->getFileID()];
    }

    public function getUsedCollection()
    {
        return $this->getCollectionObject();
    }

    /**
     * @return \Concrete\Core\Statistics\UsageTracker\AggregateTracker
     */
    protected function getTracker()
    {
        if ($this->tracker === null) {
            $this->tracker = $this->app->make(AggregateTracker::class);
        }

        return $this->tracker;
    }
}
