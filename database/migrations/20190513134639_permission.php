<?php

use think\migration\Migrator;
use think\migration\db\Column;

class Permission extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $tables = config('permission.tables');

        // 规则表
        $table = $this->table($tables['permission'], array('engine'=>'MyISAM'));
        $table->addColumn('name', 'string', array('limit' => 100,'default'=>'','comment'=>'规则名称'))
            ->addIndex(array('name'), array('unique' => true))
            ->create();

        // 角色
        $table = $this->table($tables['role'], array('engine'=>'MyISAM'));
        $table->addColumn('name', 'string', array('limit' => 100,'default'=>'','comment'=>'角色名称'))
            ->addIndex(array('name'), array('unique' => true))
            ->create();
        
        // 中间表
        $table = $this->table($tables['role_access'], array('engine'=>'MyISAM'));
        $table->addColumn('user_id', 'integer', array('limit' => 11,'comment'=>'用户id'))
            ->addColumn('role_id', 'integer', array('limit' => 11,'comment'=>'角色id'))
            ->create();
        
        // 多态关联(用户与角色中间表)
        $table = $this->table($tables['has_permission'], array('engine'=>'MyISAM'));
        $table->addColumn('content', 'string', array('limit' => 50,'default'=>'','comment'=>''))
            ->addColumn('common_id', 'integer', array('limit' => 11,'comment'=>''))
            ->addColumn('common_type', 'string', array('limit' => 50,'default'=>'','comment'=>''))
            ->create();
    }
}
