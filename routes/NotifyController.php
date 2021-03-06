<?hh

class NotifyController {
  public static function get(): :xhp {
    # Get the mailing lists and parse them
    $lists = Email::getLists();
    $options = <select class="form-control" name="email" />;
    foreach($lists as $list) {
      $options->appendChild(
        <option>{$list->address}</option>
      );
    }
    return
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h1 class="panel-title">Send Notification</h1>
          </div>
          <div class="panel-body">
            <form method="post" action="/notify">
              <div class="form-group">
                <label>Mailing List</label>
                {$options}
              </div>
              <div class="form-group">
                <label>Subject</label>
                <input type="text" class="form-control" name="subject" />
              </div>
              <div class="form-group">
                <label>Body</label>
                <textarea class="form-control" rows="3" name="body"></textarea>
              </div>
              <button type="submit" class="btn btn-default">Send</button>
            </form>
          </div>
        </div>
      </div>;
  }

  public static function post(): void {
    if(!isset($_POST['email']) || !isset($_POST['subject']) || !isset($_POST['body'])) {
      Flash::set('error', 'All fields must be filled out');
      Route::redirect('/notify');
    }

    Email::send($_POST['email'], $_POST['subject'], $_POST['body']);
    Flash::set('success', 'Your email was sent successfully');
    Route::redirect('/notify');
  }
}
