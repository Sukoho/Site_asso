@include('layout.header')

<body>
    <a href="{{url('/')}}" class="Form_closebtn" >&times;</a>
    <div class="desabo">
        <form  action="{{ url('desabonner') }}" method="post">
          @csrf
            <div >
                <div class="Form_titre">
                  <h2>Désabonnez-vous à la newsletter</h2>
                </div>
                <div>
                  <fieldset>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input name="email" type="email" class="Form_control "  placeholder="Votre email..." value="{{ old('email') }}">
                  </fieldset>
                </div>
                <div>
                  <fieldset>
                    <button type="submit"  class="Form_btn">Je me désabonne</button>
                  </fieldset>
                </div>
            </div>
        </form>
    </div> 

@include('layout.footer')                   