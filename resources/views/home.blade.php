<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Check sao kê Bão Yagi</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Styles -->

</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Check sao kê</a>
        </div>
    </nav>
    <div class="container">
        <form class="row g-3 mt-4 shadow-lg rounded" method="GET" action="">
            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">Từ Khoá</label>
                <input name="key" value='{{ request()->key ?? ""}}' class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-4">
                <label for="inputPassword4" class="form-label">Khoảng tiền</label>
                <select name="amount" id="" class="form-control">
                    <option value="0">Tất cả</option>
                    <option value="1" {{ request()->amount == 1 ? "selected" : "" }} >
                        0 đến 100,000 VND
                    </option>

                    <option value="2" {{ request()->amount == 2 ? "selected" : "" }}>
                        100,000 đến 500,000 VND
                    </option>

                    <option value="3" {{ request()->amount == 3 ? "selected" : "" }}>
                        500,000 đến 1,000,000 VND
                    </option>

                    <option value="4" {{ request()->amount == 4 ? "selected" : "" }}>
                        1,000,000 đến 5,000,000 VND
                    </option>

                    <option value="5" {{ request()->amount == 5 ? "selected" : "" }}>
                        5,000,000 đến 10,000,000 VND
                    </option>

                    <option value="6" {{ request()->amount == 6 ? "selected" : "" }}>
                        10,000,000 đến 50,000,000 VND
                    </option>

                    <option value="7" {{ request()->amount == 7 ? "selected" : "" }}>
                        50,000,000 đến 100,000,000 VND
                    </option>
                    <option value="8" {{ request()->amount == 8 ? "selected" : "" }}>
                        Trên 100,000,000 VND
                    </option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="inputCity" class="form-label">Sắp xếp</label>
                <select name="order" class="form-select">
                    <option value="0">------</option>
                    <option value="1" {{ request()->order == 1 ? "selected" : "" }}>Số tiền giảm dần</option>
                    <option value="2" {{ request()->order == 2 ? "selected" : "" }}>Số tiền tăng dần</option>
                </select>
            </div>
            {{-- <div class="col-md-4">
                <label for="inputState" class="form-label">Ngày bắt đầu</label>
                <input type="date" name="start" class="form-control" id="inputZip">
            </div>
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Ngày kết thúc</label>
                <input type="date" name="end" class="form-control" id="inputZip">
            </div> --}}
            <div class="col-6">
                <button type="submit" class="btn btn-success btn-block">Lọc dữ liệu</button>
                <a href="/" class="btn btn-secondary btn-block">Xoá lọc</a>
            </div>
            <div class="mb-4"></div>
        </form>
        <div class="mt-3 float-right">
            {{ $data->appends(request()->all())->links() }}
        </div>
        <table class="table table-bordered mt-4 shadow-lg rounded">
            <thead>
                <tr>
                    <th scope="col" width="20%">Ngày tháng</th>
                    <th scope="col" width="20%">Mã giao dịch</th>
                    <th scope="col" width="20%">Số tiền</th>
                    <th scope="col" width="40%">Nội dung</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td width="20%">{{Carbon\Carbon::parse($item->date)->format('d/m/Y')}}</td>
                    <td width="20%">{{$item->mgd}}</td>
                    <td width="20%">{{number_format($item->amount)}} đ</td>
                    <td width="40%" style="word-wrap: break-word;min-width: 160px;max-width: 160px;">{{$item->content}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {{ $data->appends(request()->all())->links() }}
    </div>

</body>

</html>