
    

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

<form action="{{ route('store.login') }}" method="post">
@csrf
<input type="email" name="email" id="email" placeholder="email">
<input type="password" name="password" id="password" placeholder="senha">
<input type="submit" value="logar">

</form>