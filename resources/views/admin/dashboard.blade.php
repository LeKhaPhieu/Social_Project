<h1>Giao diện admin ở đây</h1>
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button href="#">Log out</button>
</form>
