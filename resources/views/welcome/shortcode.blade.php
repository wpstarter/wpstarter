<div>
    <h2>
        Shortcode view
    </h2>
    <hr/>
    <h3>Sample form</h3>
    <form method="post">
        @csrf
        <label for="your-name">Name:</label>
        <input type="text" id="your-name" name="your_name" value="{{ws_old('your_name')}}">
        @error('your_name')
            <p style="color: red">{{$message}}</p>
        @enderror
        <button type="submit">Send</button>
    </form>
</div>