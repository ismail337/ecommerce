@extends('frontend.dashboard.layouts.master')

@section('content')
    <!--=============================
                                                                                                                                                                                                            DASHBOARD START
                                                                                                                                                                                                            =============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include('frontend.dashboard.layouts.sidebar')
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content">
                        <h3><i class="fal fa-gift-card"></i> address</h3>
                        <div class="wsus__dashboard_add">
                            <div class="row">
                                @foreach ($userAddresses as $userAddress)
                                    <div class="col-xl-6">
                                        <div class="wsus__dash_add_single">
                                            <h4>Billing Address</h4>
                                            <ul>
                                                <li><span>name :</span> {{ $userAddress->name }}</li>
                                                <li><span>Phone :</span> {{ $userAddress->phone }}</li>
                                                <li><span>email :</span> {{ $userAddress->email }}</li>
                                                <li><span>country :</span> {{ $userAddress->country }}</li>
                                                <li><span>city :</span> {{ $userAddress->city }}</li>
                                                <li><span>zip code :</span> {{ $userAddress->zip }}</li>
                                                <li><span>address :</span> {{ $userAddress->address }}</li>
                                            </ul>
                                            <div class="wsus__address_btn">
                                                <a href="{{ route('user.address.edit', $userAddress->id) }}"
                                                    class="edit"><i class="fal fa-edit"></i>
                                                    edit</a>
                                                <a href="{{ route('user.address.destroy', $userAddress->id) }}"
                                                    class="del delete-item"><i class="fal fa-trash-alt"></i> delete</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-12">
                                    <a href="{{ route('user.address.create') }}" class="add_address_btn common_btn"><i
                                            class="far fa-plus"></i>
                                        add new address</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
