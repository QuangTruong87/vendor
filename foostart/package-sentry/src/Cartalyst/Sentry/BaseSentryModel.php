<?php namespace Cartalyst\Sentry;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseSentryModel extends Model{
    use SoftDeletes;
}
