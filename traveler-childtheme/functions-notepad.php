<div class="mt30">
        <div class="form-group">
            <label> Your Name (required)
                [text* class:form-control your-name] </label>
        </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> Your Email (required)
                    [email* class:form-control your-email] </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> Your Phone Number (required)
                    [tel* class:form-control tel-170 placeholder "+1 (305) 555 5236"]</label>
            </div>
        </div>
    </div>

        <div class="form-group">
            <label> Request
                [flightrequest]</label>

        </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> Date
                    [date* class:form-control date-659]</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> Number of passengers
                    [number* class:form-control number-464 min:1 max:9]</label>
            </div>
        </div>
        </div>

        <div class="form-group">
            <label> Comments or Special Request
                [textarea class:form-control your-message] </label>
        </div>

        [getparam flightrequest]
        <div class="form-group">
            <label>Captcha</label>[recaptcha]
        </div>
        [submit class:btn class:btn-primary "Send Request"]
    </div>