<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <style>
        /* Your internal CSS here */
    </style>
</head>
<body>
    <div class="container">
        <h1>Our Menu</h1>
        <div class="menu-grid">
            @if($menu_items->count())
    @foreach($menu_items as $item)
        <div>
            <h3>{{ $item->name }}</h3>
            <p>{{ $item->description }}</p>
            <p>${{ number_format($item->price, 2) }}</p>
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
            @endif
        </div>
    @endforeach
@else
    <p>No menu items available.</p>
@endif

        </div>
    </div>
</body>
</html>
