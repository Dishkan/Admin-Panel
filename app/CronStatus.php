<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronStatus extends Model{
	public    $timestamp = false;
	protected $table      = 'cron_statuses';
	protected $primaryKey = 'name';
	protected $fillable   = [ 'name', 'status' ];
}
