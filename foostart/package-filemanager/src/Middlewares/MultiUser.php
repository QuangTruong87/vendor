<?php

namespace Foostart\Filemanager\Middlewares;

use Closure;
use Foostart\Filemanager\Traits\LfmHelpers;
use Illuminate\Support\Str;

class MultiUser
{
    use LfmHelpers;

    public function handle($request, Closure $next)
    {
        if ($this->allowMultiUser()) {
            $previous_dir = $request->input('working_dir');
            $working_dir = $this->rootFolder('user');

            if ($previous_dir == null) {
                $request->merge(compact('working_dir'));
            } elseif (!$this->validDir($previous_dir)) {
                $request->replace(compact('working_dir'));
            }
        }

        return $next($request);
    }

    private function validDir($previous_dir)
    {
        if (Str::startsWith($previous_dir, $this->rootFolder('share'))) {
            return true;
        }

        if (Str::startsWith($previous_dir, $this->rootFolder('user'))) {
            return true;
        }

        return false;
    }
}
