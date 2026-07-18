<!DOCTYPE html>
<html>
<head>
    <title>Create Customer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">

    <h2>Create Customer</h2>

    {{-- خطاها --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- فرم --}}
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
             <label>نحوه امضای قوانین</label>

    <select name="law_signature_method" class="form-control">
        <option value="">انتخاب کنید</option>
        <option value="online">آنلاین</option>
        <option value="offline">آفلاین</option>
    </select>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>

</body>
</html>