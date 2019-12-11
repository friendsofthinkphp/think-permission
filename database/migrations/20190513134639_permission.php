<?php

use think\migration\Migrator;

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
        $table = $this->table($tables['permission'], ['engine'=>'MyISAM']);
        $table->addColumn('name', 'string', ['limit' => 100, 'comment'=>'规则名称'])
            ->addIndex(['name'], ['unique' => true])
            ->create();

        // 角色表
        $table = $this->table($tables['role'], ['engine'=>'MyISAM']);
        $table->addColumn('name', 'string', ['limit' => 100, 'comment'=>'角色名称'])
            ->addIndex(['name'], ['unique' => true])
            ->create();

        // 角色与规则 多对多中间表
        $table = $this->table($tables['role_permission_access'], ['engine'=>'MyISAM']);
        $table->addColumn('role_id', 'integer', ['comment'=>'角色主键'])
            ->addColumn('permission_id', 'integer', ['comment'=>'规则主键'])
            ->addIndex(['permission_id', 'role_id'], ['unique' => true])
            ->create();

        // 角色与用户 多对多中间表
        $table = $this->table($tables['user_role_access'], ['engine'=>'MyISAM']);
        $table->addColumn('user_id', 'integer', ['comment'=>'用户id'])
            ->addColumn('role_id', 'integer', ['comment'=>'角色id'])
            ->addIndex(['user_id', 'role_id'], ['unique' => true])
            ->create();

        // 多态关联(用户与角色中间表)
        $table = $this->table($tables['has_permission'], ['engine'=>'MyISAM']);
        $table->addColumn('content', 'string', ['limit' => 50])
            ->addColumn('model_id', 'integer', ['comment'=>'模型主键'])
            ->addColumn('model_type', 'string', ['limit' => 50, 'comment'=>'模型命名空间'])
            ->create();
    }
}
