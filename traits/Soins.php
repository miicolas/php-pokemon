<?php

trait Soins
{
    public function soigner(int $pv): void
    {
        $this->pv += $pv;
    }
}
