<?php namespace Foostart\Acl\Authentication\Presenters\Traits;

use Foostart\Acl\Authentication\Models\Permission;

/**
 * Trait PermissionTrait
 *
 * @author Foostart foostart.com@gmail.com
 */
trait PermissionTrait
{
    /**
     * Obtains the permission obj associated to the model
     * @param null $model
     * @return array
     */
    public function permissions_obj($model = null)
    {
        $model = $model ? $model : new Permission;
        $objs = [];
        $permissions = $this->resource->permissions;
        if (!empty($permissions)) foreach ($permissions as $permission => $status) {
            $objs[] = (!$model::wherePermission($permission)->get()->isEmpty()) ? $model::wherePermission($permission)->first() : null;
        }
        return $objs;
    }
}
