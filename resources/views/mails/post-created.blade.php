<div>
  <h1>Email yetkazildi</h1>
  <h1>Hurmatli {{$post->user->username}}!</h1>
  <h6>Siz {{ $post->created_at }}da yangi post yaratdingiz </h6>
  <p>Post id {{ $post->id }} </p>
  <div>{{ $post->title }}</div>
  <div>{{ $post->short_content }}</div>
  <div>{{ $post->content }}</div>
  <div>Rahmat !</div>
</div>