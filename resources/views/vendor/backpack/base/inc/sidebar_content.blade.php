<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
<!-- Users, Roles Permissions -->
  <li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>

<li><a href='{{ backpack_url('office') }}'><i class='fa fa-building'></i> <span>Offices</span></a></li>

<li><a href='{{ backpack_url('supplier') }}'><i class='fa fa-barcode'></i> <span>Suppliers</span></a></li>

<li><a href='{{ backpack_url('account') }}'><i class='fa fa-credit-card'></i> <span>Accounts</span></a></li>