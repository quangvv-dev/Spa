<style>
    a.dropdown-item.d-flex.pb-3.tag-click {
        border-bottom: 1px solid #e9ecef;
    }

    .text-notification {
        width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 20px;
        -webkit-line-clamp: 2;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
</style>
@php
    $roleGlobal = auth()->user()?:[];
    $checkRole = checkRoleAlready();
@endphp
