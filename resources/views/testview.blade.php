<h1>Registration form</h1>

<form action="{{route('update-name')}}" method="POST">
    @csrf
    @method('PUT')
    <label>Name</label>
    <input type="text" placeholder="Name" name="fullname">
    <button type="submit">Gui</button>
</form>
