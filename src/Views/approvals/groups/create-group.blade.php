<h2>Create Group</h2>
<!-- Begin Create Group Section -->
<section>

    <form action="/group" method="post">
        @csrf
        <div class="form-group">
            <label>Group Name</label>
            <input type="text" name="name">
        </div>

        <div class="form-group">
            <label>Group Description</label>
            <input type="text" name="description">
        </div>

        <div class="form-group">
            <input type="submit" value="Create Group">
        </div>

    </form>

</section>
<!-- End Create Group Section -->