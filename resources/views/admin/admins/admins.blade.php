@extends('layouts.sideBar')
@section('title', 'الأدمن')

@section('content')

    <div class="container mt-5">
        <h2 class="text-center mb-4">قائمة الأدمنز المسؤولين</h2>
        <div class="card shadow rounded">
            <div class="card-body">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الحالة</th>
                            <th>تاريخ الانضمام</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>{{$admin->id}}</td>
                                <td>{{$admin->name}}</td>
                                <td>{{$admin->email}}</td>
                                <td><span class="badge bg-success">نشط</span></td>
                                <td>{{$admin->created_at}}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning">تعديل</button>
                                    <button class="btn btn-sm btn-danger">تعطيل</button>
                                </td>
                            </tr>
                        @endforeach
                        <!-- تكرار الصفوف حسب البيانات -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection