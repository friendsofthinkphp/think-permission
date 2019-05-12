<?php
namespace xiaodi\Permission\Models;

use think\Model;
use xiaodi\Permission\Validate\Permission as Validate;

/**
 * 权限模型
 * 
 */
class Permission extends Model
{
    public function __construct($data = [])
    {
        $prefix = config('database.prefix');
        $name = config('permission.tables.permission');
        $table = [$prefix, $name];

        $this->pk = 'id';
        $this->table = implode('', $table);

        parent::__construct($data);
    }

    /**
     * 数据验证
     * @param array $data
     * @param string $scene
     */
    public static function validate($data, $scene)
    {
        $validate = new Validate;

        if (!$validate->scene($scene)->check($data)) {
            exception($validate->getError());
        }
    }

    /**
     * 添加规则
     * @param array $data
     */
    public function add(array $data)
    {
        try {
            self::validate($data, 'create');
            $this->save($data);
        } catch(\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 修改规则
     * @param array $data
     */
    public function edit(int $id, array $data)
    {
        try {
            $info = $this->getInfo($id);
            self::validate($data, 'update');
            $info->save($data);
        } catch (\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 删除规则
     * @param string|int $id
     */
    public function deleteRule($id)
    {
        try {
            $info = $this->getInfo($id);

            // 检查是否有子规则
            $res = $this->getChild($info->id);
            
            if (!empty($res)) {
                exception('请删除子规则');
            }
            
            $info->delete();
        } catch (\Exception $e) {
            exception($e->getMessage());
        }
    }

    /**
     * 获取树形结构
     *
     */
    public function getTree()
    {
        $data = $this->order('pid asc')->select();
        $category = new \lib\Category(array('id','pid','title','cname'));
        $res = $category->getTree($data); //获取分类数据树结构
        return $res;
    }

    /**
     * 获取规则详情
     * @param int|string $id
     *
     */
    public function getInfo($id)
    {
        $res = $this->getOrFail($id);

        return $res;
    }

    /**
     * 获取子规则
     * @param string|int $pid
     * @return array
     */
    protected function getChild($pid)
    {
        $data = $this->order('pid asc')->select();
        $category = new \lib\Category(array('id','pid','title','cname'));
        $data = $category->getChild($pid, $data);

        return $data;
    }
}
