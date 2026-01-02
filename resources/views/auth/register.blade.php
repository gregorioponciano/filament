



                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

<form action="{{ route('store.register') }}" method="post">
@csrf

<input type="text" name="name" id="name" placeholder="nome">
<input type="email" name="email" id="email" placeholder="email">
<input type="password" name="password">
<input type="submit" value="register">

</form>