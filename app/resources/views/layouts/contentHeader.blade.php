<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">
                    @switch(true)
                        @case(request()->routeIs('admin.dashboard') || request()->routeIs('home-cms') )
                            Dashboard
                            @break

                        @case(request()->routeIs('admin.users.*'))
                            Users
                            @break

                        @case(request()->routeIs('admin.cars.*'))
                            Mobil
                            @break

                        @case(request()->routeIs('admin.downPayment.edit'))
                            Refund DP
                            @break

                        @case(request()->routeIs('admin.downPayment.*'))
                            Down Payment(DP)
                            @break

                        @case(request()->routeIs('admin.offer.*'))
                            Permintaan Penjualan 
                            @break

                        @case(request()->routeIs('admin.salesRecord.*'))
                            Catatan Transaksi Pembelian
                            @break  

                        @case(request()->routeIs('admin.offerRecord.*'))
                            Catatan Transaksi Penjualan
                            @break  

                        @case(request()->routeIs('user.dashboard') || request()->routeIs('home-cms') )
                            Dashboard
                            @break

                        @case(request()->routeIs('user.downPayment.*'))
                            Pembayaran DP
                            @break

                        @case(request()->routeIs('user.offer.*'))
                            Penjualan Mobil
                            @break
                        @case(request()->routeIs('user.transactionSalesRecord.*'))
                            Transaksi Pembelian Mobil
                            @break
                        @case(request()->routeIs('user.transactionOfferRecord.*'))
                            Transaksi Penjualan Mobil
                            @break

                        @default
                            Halaman
                    @endswitch

                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home-cms') }}">Home</a>
                    </li>

                    @switch(true)

                        {{-- admin.Dashboard --}}
                        @case(request()->routeIs('admin.dashboard') || request()->routeIs('home-cms') )
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            @break

                        {{-- admin.users.index --}}
                        @case(request()->routeIs('admin.users.index'))
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                            @break
                        {{-- admin.users.create --}}
                        @case(request()->routeIs('admin.users.create'))
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                            @break
                        {{-- admin.users.edit --}}
                        @case(request()->routeIs('admin.users.edit'))
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.users.index') }}">Users</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            @break

                        {{-- admin.cars.index --}}
                        @case(request()->routeIs('admin.cars.index'))
                            <li class="breadcrumb-item active" aria-current="page">Mobil</li>
                            @break
                        {{-- admin.cars.create --}}
                        @case(request()->routeIs('admin.cars.create'))
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cars.index') }}">Mobil</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                            @break
                        {{-- admin.cars.edit --}}
                        @case(request()->routeIs('admin.cars.edit'))
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.cars.index') }}">Mobil</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                            @break

                        {{-- admin.offer.index --}}
                        @case(request()->routeIs('admin.offer.index'))
                            <li class="breadcrumb-item active" aria-current="page">Permintaan Penjualan</li>
                            @break
                        {{-- admin.offer.show --}}
                        @case(request()->routeIs('admin.offer.show'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('admin.offer.index')}}">Permintaan Penjualan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                            @break
                            
                        {{-- admin.downPayment.index --}}
                        @case(request()->routeIs('admin.downPayment.index'))
                            <li class="breadcrumb-item active" aria-current="page">Down Payment(DP)</li>
                            @break
                        {{-- admin.downPayment.addRefund --}}
                        @case(request()->routeIs('admin.downPayment.addRefund'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('admin.downPayment.index')}}">Down Payment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Refund</li>
                            @break
                        {{-- admin.downPayment.editRefund --}}
                        @case(request()->routeIs('admin.downPayment.editRefund'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('admin.downPayment.index')}}">Down Payment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Refund</li>
                            @break

                        {{-- admin.salesRecord.index --}}
                        @case(request()->routeIs('admin.salesRecord.index'))
                            <li class="breadcrumb-item active" aria-current="page">Catatan Transaksi Pembelian</li>
                            @break
                        {{-- admin.salesRecord.create --}}
                        @case(request()->routeIs('admin.salesRecord.create'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('admin.salesRecord.index')}}">Catatan Transaksi Pembelian</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                            @break
                        {{-- admin.offerRecord.index --}}
                        @case(request()->routeIs('admin.offerRecord.index'))
                            <li class="breadcrumb-item active" aria-current="page">Catatan Transaksi Penjualan</li>
                            @break
                        {{-- admin.offerRecord.create --}}
                        @case(request()->routeIs('admin.offerRecord.create'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('admin.offerRecord.index')}}">Catatan Transaksi Penjualan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                            @break
                            
                        {{-- user.dashboard --}}
                        @case(request()->routeIs('user.dashboard') || request()->routeIs('home-cms') )
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            @break

                        {{--user.downPayment.index  --}}
                        @case(request()->routeIs('user.downPayment.index'))
                            <li class="breadcrumb-item active" aria-current="page">Down Payment</li>
                            @break
                        {{-- user.downPayment.checkout --}}
                        @case(request()->routeIs('user.downPayment.checkout'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('user.downPayment.index')}}">Down Payment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            @break
                        @case(request()->routeIs('user.downPayment.show'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('user.downPayment.index')}}">Down Payment</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                            @break

                        {{--user.Offer.index  --}}
                        @case(request()->routeIs('user.offer.index'))
                            <li class="breadcrumb-item active" aria-current="page">Penjualan Mobil</li>
                            @break
                        {{-- user.offer.show --}}
                        @case(request()->routeIs('user.offer.show'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('user.offer.index')}}">Penjualan Mobil</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                            @break
                            
                            {{-- user.transactionSalesRecord.index --}}
                            @case(request()->routeIs('user.transactionSalesRecord.index'))
                            
                            <li class="breadcrumb-item active" aria-current="page">Transaksi Pembelian Mobil</li>
                            @break
                            
                            @case(request()->routeIs('user.transactionSalesRecord.createTesti'))
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="{{route('user.transactionSalesRecord.index')}}">Transaksi Pembelian Mobil</a>
                            </li>
                            
                            <li class="breadcrumb-item active" aria-current="page">Testimoni</li>
                            @break

                        {{-- user.transactionOfferRecord.index --}}
                        @case(request()->routeIs('user.transactionOfferRecord.index'))
                           
                            <li class="breadcrumb-item active" aria-current="page">Transaksi Penjualan Mobil</li>
                            @break



                        @default
                            <li class="breadcrumb-item active" aria-current="page">Halaman</li>
                    @endswitch
                </ol>
            </div>

        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
