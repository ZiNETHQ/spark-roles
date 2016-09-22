<?php
namespace ZiNETHQ\SparkRoles\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPermission extends Model
{
	/**
	 * The attributes that are fillable via mass assignment.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'description'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'team_permissions';

	/**
	 * Permissions can belong to many roles.
	 *
	 * @return Model
	 */
	public function roles()
	{
		return $this->belongsToMany('\ZiNETHQ\SparkRoles\Models\TeamRole')->withTimestamps();
	}

	/**
	 * Assigns the given role to the permission.
	 *
	 * @param  integer  $roleId
	 * @return bool
	 */
	public function assignRole($roleId = null)
	{
		$roles = $this->roles;

		if (! $roles->contains($roleId)) {
			return $this->roles()->attach($roleId);
		}

		return false;
	}

	/**
	 * Revokes the given role from the permission.
	 *
	 * @param  integer  $roleId
	 * @return bool
	 */
	public function revokeRole($roleId = '')
	{
		return $this->roles()->detach($roleId);
	}

	/**
	 * Syncs the given role(s) with the permission.
	 *
	 * @param  array  $roleIds
	 * @return bool
	 */
	public function syncRoles(array $roleIds = array())
	{
		return $this->roles()->sync($roleIds);
	}

	/**
	 * Revokes all roles from the permission.
	 *
	 * @return bool
	 */
	public function revokeAllRoles()
	{
		return $this->roles()->detach();
	}
}