@include('layout.header')
<body>
<div  class="Form_overlay">
    <a href="{{url('/')}}" class="Form_closebtn" >&times;</a>
    <div class="Form_overlay-content">
        <form  action="{{ url('formulaire') }}" method="post">
          @csrf
            <div >
                <div class="Form_titre">
                  <h2>Contactez-moi</h2>
                </div>
                <div>
                  <fieldset>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input name="name" type="text" class="Form_control "  placeholder="Votre nom..." value="{{ old('name') }}">
                  </fieldset>
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
                    @error('message')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <textarea name="message"  class="Form_control Form_message "  placeholder="Votre message..." >{{ old('message') }}</textarea>
                  </fieldset>
                </div>
                <div>
                  <fieldset>
                    <button type="submit"  class="Form_btn">Envoyer un message</button>
                  </fieldset>
                </div>
            </div>
        </form>
    </div> 
</div>
@include('layout.footer')                   
