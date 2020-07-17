@can('follow', $user)
    <div class="text-center mt-2 mb-4">
        @if (Auth::user()->isFollowing($user->id))
            <form action="{{ route('followers.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-outline-primary">取消关注</button>
            </form>
        @else
            @can('follow', $user)

                <form action="{{ route('followers.store', $user->id) }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-sm btn-primary">关注</button>
                </form>
            @endcan
        @endif
    </div>
@endcan
