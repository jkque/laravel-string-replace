<?php

namespace Jkque\StringReplace;

interface StringReplacePipe
{
    public function handle($string, callable $next);
}
