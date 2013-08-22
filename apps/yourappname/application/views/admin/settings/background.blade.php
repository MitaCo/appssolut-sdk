<aside id="sidebar">
    <div id="settings_front">
        <h4>Edit Background</h4>
        <div id="myModal_content">
            <div class="modal-body modal_end">
                <p>Upload a background image from your computer. Image will be repeated horizontally and vertically.</p>
                <p>Recommended maximum width: 810 pixels</p>
                @if(!empty($instance->setting->background) &&  !str_contains($instance->setting->background, '#'))
                    <p><img src="{{$instance->setting->background}}"/></p>
                @endif
            </div>
            {{ Form::open_for_files(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT', array('class' => 'navbar-form pull-left', 'id' => 'upload')) }}
            <div class="modal-body">
               
                <ul>
                    <!-- The file uploads will be shown here -->
                </ul>
                <div id="drop">
                    Upload file
                    <a>Browse</a>
                    <input type="file" name="value"/>
                </div>
                <!--<div id="restore_btn">
                    <a href="" class="bt bgcolor">Restore background</a>
                </div>-->
                <br />
                <div id="upgrade_btn">
                    <a href="" class="bt bgcolor">Choose background color</a>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
                <button class="modal-button btn">Save</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
    <div id="settings_upgrade">
        <h4>Background color</h4>
        <div id="myModal_content">
            <div class="modal-body modal_end">
                <p>Here you can choose background color for your application.</p>
            </div>
            {{ Form::open_for_files(URL::to_route('app_save_settings', array ($instance->instance, $page)), 'PUT', array('class' => 'navbar-form pull-left', 'id' => 'upload')) }}
            <div class="modal-body">
                    
                {{ render('admin.settings.colorpicker', array( 'color' => is_null($instance->setting->background) ? '#FFFFFF' :  $instance->setting->background)) }}
                <!--<div id="restore_btn">
                    <a href="" class="bt bgcolor">Restore background</a>
                </div>-->
                <br />
                <div id="upgrade_btn">
                    <a href="" class="bt bgimage">Choose background image</a>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{ URL::to_route('app_list_fields', array($instance->instance, $page)) }}" class="btn cancel" data-dismiss="modal">Cancel</a>
                <button class="modal-button btn">Save</button>
            </div>
            {{ Form::close() }}
        </div>
       
    </div>
</aside>