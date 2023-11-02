<?php

namespace Application\Block\ResponsiveTable;

use Concrete\Core\Block\BlockController;
use Database;
use Core;

class Controller extends BlockController {

    protected $btTable = 'btResponsiveTable';
    protected $btItems = 'btResponsiveTableItems';
    protected $btExportTables = array('btResponsiveTable', 'btResponsiveTableItems');

    protected $btDefaultSet = 'basic';

    protected $btInterfaceWidth  = 1050;
    protected $btInterfaceHeight = 400;

    protected $rows = array();

    public function getBlockTypeName() {
        return t('Table');
    }

    public function getBlockTypeDescription() {
        return t('Responsive Table');
    }

    public function getAllowedClasses() {

	    $allowedClasses= array(
            'header-1' => 'Header 1',
            'header-2' => 'Header 2',
            'header-3' => 'Header 3'
	    );

        return $allowedClasses;
    }

    public function getRows() {
		return $this->rows;
    }

    public function getColumnCount() {
        $columnCount = 0;
        foreach ($this->getRows() as $row) {
            $columnCount = max($columnCount, count($row['data']));
        }
        $columnCount = intval($columnCount) ?: 1;
        return $columnCount;
    }

    protected function loadRows() {
		$bID = intval($this->bID);
        $this->rows = array();
        if ($bID) {
	        $this->rows = Database::connection()->getAll("SELECT * FROM {$this->btItems} WHERE bID = ?", array($bID));
            foreach ($this->rows as &$row) {
                $row['data'] = unserialize($row['data']);
            }
        }
    }

    public function loadBlockInformation() {
        $this->loadRows();
        $this->set('rows',        $this->getRows());
        $this->set('columnCount', $this->getColumnCount());
        $this->set('classes',     $this->getAllowedClasses());
    }


	public function add() {
		$this->edit();
    }

	public function edit() {
        $this->loadBlockInformation();
    }

    public function view() {
        $this->loadBlockInformation();
    }

	public function save($data) {
        if (count($data['data'])) {
            $this->delete(false);
            foreach ($data['data'] as $id => $row) {
                $excludeEmpties = array_filter($row);
                if ( ! empty($excludeEmpties)) {
	                Database::connection()->query("INSERT INTO {$this->btItems} (bID, data, class) VALUES (?, ?, ?)", array(
                        intval($this->bID),
                        serialize($row),
                        (isset($data['class'][$id])) ? $data['class'][$id] : ''
                    ));
                }
            }
        }
        $data['useFirstRowAsHeaders'] = (isset($data['useFirstRowAsHeaders'])) ? 1 : 0;
        $data['hideHeadersOnDesktop'] = (isset($data['hideHeadersOnDesktop']) && $data['useFirstRowAsHeaders']) ? 1 : 0;
        parent::save($data);
    }

    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Database::get();
        $values = array($this->bID);
        $query = 'select * from btResponsiveTableItems where bID = ?';
        $r = $db->query($query, $values);

        while ($row = $r->FetchRow()) {
            $db->execute('INSERT INTO btResponsiveTableItems (bID, class, data) values(?,?,?)',
                array(
                    $newBID,
                    $row['class'],
                    $row['data'],
                )
            );
        }
    }

    public function delete($parentDelete = true) {
	    Database::connection()->query("DELETE FROM {$this->btItems} WHERE bID = ?", array(intval($this->bID)));
        if ($parentDelete) {
            parent::delete();
        }
    }

	public function getSearchableContent() {
		$this->loadRows();
		$rows = $this->getRows();
		$content = '';
		foreach ((array) $rows as $row) {
			$content .= ($content) ? "\r\n" : '';
			$content .= implode(' ', $row['data']);
		}
		return $content;
	}

}

?>