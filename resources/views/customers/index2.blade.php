@extends('layout2.app')
@php
    $roleGlobal = auth()->user()?:[];
    $checkRole = checkRoleAlready();
@endphp