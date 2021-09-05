<div class="row mb-3 mt-3">
    <div class="col-sm-12 col-md-4 mb-3">
        <!-- <label for="userPictrue">個人圖片</label> -->
        <div class="w-100">
            <!-- <div class="col-md-2 col-sm-2 col-lg-2 .col-xs-2"> -->
        @if($UserData->user_picture=="")
            <img id="imagePreview" class="image-circle" src="/images/icon/NoImage.jpg">
        @else
            <img id="imagePreview" class="image-circle" src="{{ $UserData->user_picture }}">
        @endif
            <!-- </div> -->
        </div>
        <input type="file" id="uploadImage" name="uploadImage" accept=".png,.jpg" style="display: none;">
        <!-- <input name="userPictrue" class="form-control" type="text" value="{{ $UserData->user_picture }}" placeholder="請輸入使用者名稱"/> -->
    </div>
    <div class="col-sm-12 col-md-8">

        <div class="row mb-3">
            <div class="col-sm-12 col-md-3">
                <strong>姓名</strong>
            </div>
            <div class="col-sm-12 col-md-8">
                <label for="account">{{ $UserData->nickname }}</label>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-12 col-md-3">
                <strong>E-Mail</strong>
            </div>
            <div class="col-sm-12 col-md-8">
                <label for="account">{{ $UserData->email }}</label>
            </div>
        </div>

    </div>
</div>