<?php
namespace Application\Block\ToggleList;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Editor\LinkAbstractor;

class Controller extends BlockController
{
    protected $btInterfaceWidth = 600;
    protected $btInterfaceHeight = 465;
    protected $btTable = 'btToggleList';
    protected $btExportTables = ['btToggleList', 'btToggleListEntries'];
    protected $btWrapperClass = 'ccm-ui';
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = true;
    protected $btDefaultSet = 'basic';

    public function getBlockTypeName()
    {
        return t('Toggle List');
    }

    public function getBlockTypeDescription()
    {
        return t('List of accordion / toggle type content');
    }

    public function getSearchableContent()
    {
        $content = '';
        $db = $this->app->make('database')->connection();
        $v = [$this->bID];
        $q = 'SELECT * FROM btToggleListEntries WHERE bID = ?';
        $r = $db->executeQuery($q, $v);
        foreach ($r as $row) {
            $content .= $row['title'] . ' ' . $row['description'];
        }

        return $content;
    }

    public function edit()
    {
        $db = $this->app->make('database')->connection();
        $rows = $db->fetchAll('SELECT * FROM btToggleListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);

        $query = [];
        foreach ($rows as $q) {
            $q['description'] = LinkAbstractor::translateFromEditMode($q['description']);
            $query[] = $q;
        }

        $this->set('rows', $query);
    }

    public function view()
    {
        $db = $this->app->make('database')->connection();
        $query = $db->fetchAll('SELECT * FROM btToggleListEntries WHERE bID = ? ORDER BY sortOrder', [$this->bID]);

        $rows = [];
        foreach ($query as $row) {
            $row['description'] = LinkAbstractor::translateFrom($row['description']);
            $rows[] = $row;
        }

        $this->set('rows', $rows);
    }

    public function duplicate($newBID)
    {
        $db = $this->app->make(Connection::class);
        $copyFields = 'title, description, sortOrder';
        $db->executeUpdate(
            "INSERT INTO btToggleListEntries (bID, {$copyFields}) SELECT ?, {$copyFields} FROM btToggleListEntries WHERE bID = ?",
            [
                $newBID,
                $this->bID,
            ]
        );
    }

    public function delete()
    {
        $db = $this->app->make('database')->connection();
        $db->executeQuery('DELETE FROM btToggleListEntries WHERE bID = ?', [$this->bID]);
        parent::delete();
    }

    public function save($args)
    {
        $db = $this->app->make('database')->connection();
        $db->executeQuery('DELETE FROM btToggleListEntries WHERE bID = ?', [$this->bID]);
        parent::save($args);
        $count = isset($args['sortOrder']) ? count($args['sortOrder']) : 0;

        $i = 0;
        while ($i < $count) {
            if (isset($args['description'][$i])) {
                $args['description'][$i] = LinkAbstractor::translateTo($args['description'][$i]);
            }

            $db->executeQuery(
                'INSERT INTO btToggleListEntries (bID, title, description, sortOrder) VALUES(?,?,?,?)',
                [
                    $this->bID,
                    $args['title'][$i],
                    $args['description'][$i],
                    $args['sortOrder'][$i],
                ]
            );
            ++$i;
        }
    }
}
