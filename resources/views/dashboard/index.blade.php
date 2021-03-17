@extends('layout.app')
@section('content')
    <div class=" col-lg-12">
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-purple">
                            <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                                <i class="fas fa-users text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-1 text-primary counter font-30">678</h3>
                        <div class="text-muted">Visitors online</div>
                    </div>
                    <div class="card-chart-bg">
                        <div id="chart-bg-users-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-purple">
                            <div class="icon icon-shape bg-gradient-red rounded-circle text-white">
                                <i class="fas fa-cart-plus text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-1  text-red counter font-30">567</h3>
                        <div class="text-muted">Total Sales</div>
                    </div>
                    <div class="card-chart-bg">
                        <div id="chart-bg-users-2" style="height: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-purple">
                            <div class="icon icon-shape bg-gradient-orange rounded-circle text-white">
                                <i class="fas fa-edit text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-1  text-orange counter font-30">56</h3>
                        <div class="text-muted">Total Projects</div>
                    </div>
                    <div class="card-chart-bg">
                        <div id="chart-bg-users-3" style="height: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-value float-right text-purple">
                            <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                        </div>
                        <h3 class="mb-1  text-green font-30">$<span class="counter">56,755</span></h3>
                        <div class="text-muted">Today Income</div>
                    </div>
                    <div class="card-chart-bg">
                        <div id="chart-bg-users-4" style="height: 100%"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-status bg-success br-tr-3 br-tl-3"></div>
            <div class="card-header">
                <h3 class="card-title">Sales Report</h3>
            </div>
            <div id="chart-tasks" class="chart-tasks"></div>
            <div class="table-responsive border-top">
                <table class="table card-table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th colspan="2">User</th>
                        <th>Feed back</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>2345</td>
                        <td><span class="avatar brround " style="background-image: url(assets/images/faces/male/1.jpg)"></span></td>
                        <td>Megan Peters</td>
                        <td>please check pricing Info </td>
                        <td class="text-nowrap">July 13, 2018</td>
                        <td class="w-1"><a href="#" class="icon"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>4562</td>
                        <td><span class="avatar brround" style="background-image: url(assets/images/faces/female/1.jpg)"></span></td>
                        <td>Phil Vance</td>
                        <td>New stock</td>
                        <td class="text-nowrap">June 15, 2018</td>
                        <td><a href="#" class="icon"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>8765</td>
                        <td><span class="avatar brround">AS</span></td>
                        <td>Adam Sharp</td>
                        <td>Daily updates</td>
                        <td class="text-nowrap">July 8, 2018</td>
                        <td><a href="#" class="icon"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>2665</td>
                        <td><span class="avatar brround" style="background-image: url(assets/images/faces/male/4.jpg)"></span></td>
                        <td>Samantha Slater</td>
                        <td>available item list</td>
                        <td class="text-nowrap">June 28, 2018</td>
                        <td><a href="#" class="icon"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    <tr>
                        <td>1245</td>
                        <td><span class="avatar brround" style="background-image: url(assets/images/faces/female/11.jpg)"></span></td>
                        <td>Joanne Nash</td>
                        <td>Provide Best Services</td>
                        <td class="text-nowrap">July 2, 2018</td>
                        <td><a href="#" class="icon"><i class="fas fa-trash"></i></a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6 col-sm-12">
        <div class="card card-aside">
            <a href="#" class="card-aside-column" style="background-image: url(assets/images/photos/10.jpg)"></a>
            <div class="card-body d-flex flex-column">
                <h4><a href="#"> Wonderful place to visit .</a></h4>
                <div class="text-muted">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</div>
                <div class="d-flex align-items-center pt-3 mt-auto">
                    <div class="avatar brround avatar-md mr-3" style="background-image: url(assets/images/faces/female/20.jpg)"></div>
                    <div>
                        <a href="profile.html" class="text-default">Anna Ogden</a>
                        <small class="d-block text-muted">1 hour ago</small>
                    </div>
                    <div class="ml-auto text-muted">
                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-thumbs-up mr-1"></i></a>
                    </div>
                    <div class="ml-auto text-muted">
                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-message-square mr-1"></i></a>
                    </div>
                    <div class="ml-auto text-muted">
                        <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-share-2 mr-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-status bg-yellow br-tr-3 br-tl-3"></div>
                    <div class="card-header">
                        <h3 class="card-title">Sales Status</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-donut" class="chart-donut"></div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-status bg-indigo br-tr-3 br-tl-3"></div>
                    <div class="card-header">
                        <h3 class="card-title">Profit Status</h3>
                    </div>
                    <div class="card-body">
                        <div id="chart-pie" class="chart-pie"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-8">
        <div class="properties">
            <div class="card">
                <div class="card-status bg-primary br-tr-3 br-tl-3"></div>
                <div class="card-header">
                    <h4 class="card-title">Recent Sales Details</h4>
                    <div class="card-toolbar">
                        <ul>
                            <li>
                                <a class="text-gray" href="#">
                                    <i class="lni-more-alt"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-media">
                        <li class="list-item mt-4 border-bottom">
                            <div class="client-item">
                                <div class="media-img">
                                    <img alt="profile image" class="img-sm rounded-circle mb-4 mb-md-0" src="assets/images/faces/female/21.jpg">
                                </div>
                                <div class="info">
                                    <h4 class="font-weight-semibold"><a href="#">Apple iPhone 7 Plus 256GB Red Special Edition</a></h4>
                                    <p class="m-0">20 July 2018, John Doe</p>
                                    <div class="text-right">
                                        <button class="btn btn-success">Rent</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-item mt-4 border-bottom">
                            <div class="client-item">
                                <div class="media-img">
                                    <img alt="profile image" class="img-sm rounded-circle mb-4 mb-md-0" src="assets/images/faces/male/20.jpg">
                                </div>
                                <div class="info">
                                    <h4 class="font-weight-semibold"><a href="#">Huawei Mate 10 Pro Dual SIM Gray</a></h4>
                                    <p class="m-0">17 July 2018, Venessa Fern</p>
                                    <div class="text-right">
                                        <button class="btn btn-common">Sale</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-item mt-4">
                            <div class="client-item">
                                <div class="media-img">
                                    <img alt="profile image" class="img-sm rounded-circle mb-4 mb-md-0" src="assets/images/faces/female/25.jpg">
                                </div>
                                <div class="info">
                                    <h4 class="font-weight-semibold"><a href="#">Mens Jackets</a></h4>
                                    <p class="m-0">13 July 2018, Danielle M. Stong</p>
                                    <div class="text-right">
                                        <button class="btn btn-success">Rent</button>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-status bg-azure br-tr-3 br-tl-3"></div>
            <div class="card-header">
                <h2 class="card-title">Activity Details</h2>
            </div>
            <table class="table card-table">
                <tr>
                    <td>Wordpress Template</td>
                    <td class="text-right">
                        <span class="badge badge-primary">25%</span>
                    </td>
                </tr>
                <tr>
                    <td>Blog Page</td>
                    <td class="text-right">
                        <span class="badge badge-warning">Pending</span>
                    </td>
                </tr>
                <tr>
                    <td>Designing websites</td>
                    <td class="text-right">
                        <span class="badge badge-danger">12%</span>
                    </td>
                </tr>
                <tr>
                    <td>E commerce Blog</td>
                    <td class="text-right">
                        <span class="badge badge-default">60%</span>
                    </td>
                </tr>
                <tr>
                    <td>E-mail Templates</td>
                    <td class="text-right">
                        <span class="badge badge-secondary">15%</span>
                    </td>
                </tr>
                <tr>
                    <td>Business Website</td>
                    <td class="text-right">
                        <span class="badge badge-success">Finished</span>
                    </td>
                </tr>

            </table>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-status bg-pink br-tr-3 br-tl-3"></div>
            <div class="card-header">
                <h2 class="card-title">Activity Details</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                    <thead>
                    <tr>
                        <th class="text-center w-1"><i class="icon-people"></i></th>
                        <th>User</th>
                        <th>Status</th>
                        <th class="text-center">Items</th>
                        <th class="text-center">Statistics</th>
                        <th>Activity</th>
                        <th class="text-center"><i class="icon-settings"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/26.jpg)">
                                <span class="avatar-status bg-green"></span>
                            </div>
                        </td>
                        <td>
                            <div>Rose Gill</div>
                            <div class="small text-muted">Registered: May 23, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>67%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-cyan" role="progressbar" style="width: 67%"
                                     aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>03</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.67" data-thickness="3" data-color="#17a2b8">
                                <div class="chart-circle-value">67%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>10 minutes ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something more</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Another link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/17.jpg)">
                                <span class="avatar-status bg-gray"></span>
                            </div>
                        </td>
                        <td>
                            <div>Anne Arnold</div>
                            <div class="small text-muted">Registered: June 22, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>12%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-red" role="progressbar" style="width: 12%"
                                     aria-valuenow="12" aria-valuemin="12" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>01</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.12" data-thickness="3" data-color="#c21a1a">
                                <div class="chart-circle-value">12%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>12 hours ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something more</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Another link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/21.jpg)">
                                <span class="avatar-status bg-green"></span>
                            </div>
                        </td>
                        <td>
                            <div>Carol Paige</div>
                            <div class="small text-muted">Registered: May  12, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>83%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-green" role="progressbar" style="width: 83%"
                                     aria-valuenow="83" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>04</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.83" data-thickness="3" data-color="#4ecc48">
                                <div class="chart-circle-value">83%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>Just Now</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something more</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Another link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar  brround d-block" style="background-image: url(assets/images/faces/male/32.jpg)">
                                <span class="avatar-status bg-red"></span>
                            </div>
                        </td>
                        <td>
                            <div>Fiona Hodges</div>
                            <div class="small text-muted">Registered: May 11, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>33%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-pink" role="progressbar" style="width: 33%"
                                     aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>02</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.33" data-thickness="3" data-color="#ec82ef">
                                <div class="chart-circle-value">33%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>5 hours ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something more</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Another link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/12.jpg)">
                                <span class="avatar-status bg-red"></span>
                            </div>
                        </td>
                        <td>
                            <div>Jake Skinner</div>
                            <div class="small text-muted">Registered: May 22, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>25%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-orange" role="progressbar" style="width: 25%"
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>02</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.25" data-thickness="3" data-color="#fc7303">
                                <div class="chart-circle-value">25%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>2 hours ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Edit </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something more</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Another link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/4.jpg)">
                                <span class="avatar-status bg-gray"></span>
                            </div>
                        </td>
                        <td>
                            <div>Paul Terry</div>
                            <div class="small text-muted">Registered: June 20, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>9%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-red" role="progressbar" style="width: 9%"
                                     aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>01</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.09" data-thickness="3" data-color="#c21a1a">
                                <div class="chart-circle-value">9%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>12 hours ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/female/27.jpg)">
                                <span class="avatar-status bg-green"></span>
                            </div>
                        </td>
                        <td>
                            <div>Julia King</div>
                            <div class="small text-muted">Registered: June 12, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>41%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-purple" role="progressbar" style="width: 41%"
                                     aria-valuenow="41" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>03</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.41" data-thickness="3" data-color="#867efc">
                                <div class="chart-circle-value">41%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>30 min ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <div class="avatar brround d-block" style="background-image: url(assets/images/faces/male/20.jpg)">
                                <span class="avatar-status bg-green"></span>
                            </div>
                        </td>
                        <td>
                            <div>Megan Peters</div>
                            <div class="small text-muted">Registered: June 15, 2018</div>
                        </td>
                        <td>
                            <div class="clearfix">
                                <div class="float-left">
                                    <strong>59%</strong>
                                </div>
                                <div class="float-right">
                                    <small class="text-muted">March 01, 2018 - Sep 30, 2018</small>
                                </div>
                            </div>
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-indigo" role="progressbar" style="width: 59%"
                                     aria-valuenow="59" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h4>04</h4>
                        </td>

                        <td class="text-center">
                            <div class="mx-auto chart-circle chart-circle-xs" data-value="0.59" data-thickness="3" data-color="#6574cd">
                                <div class="chart-circle-value">59%</div>
                            </div>
                        </td>
                        <td>
                            <div class="small text-muted">Last login</div>
                            <div>1 hours ago</div>
                        </td>
                        <td class="text-center">
                            <div class="item-action dropdown">
                                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-tag"></i> Action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-edit-2"></i> Another action </a>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-message-square"></i> Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="javascript:void(0)" class="dropdown-item"><i class="dropdown-icon fe fe-link"></i> Separated link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
