<h2>Update Group</h2>
<!-- Begin Update Group Section -->
<section>
    <form action="/group/{{ $group->id }}" method="POST">
        @csrf

        <input type="hidden" name="_method" value="PUT">

        <div class="form-group">
            <label>Group Name</label>
            <input type="text" name="name" value="{{ $group->name }}">
        </div>

        <div class="form-group">
            <label>Group Description</label>
            <input type="text" name="description" value="{{ $group->description }}">
        </div>

        <div class="form-group">
            <input type="submit" value="Update Group">
        </div>

    </form>

</section>
<!-- End Update Group Section -->