function generataUsers(secondClass = "", main = $(document)) {
    main.find(".usuario").each(function() {
        let self = this;


        $.ajax({
                url: "dbActions/dbInfo.php",
                data: {
                    "option": 1,
                    "id": self.dataset.id
                },
                method: "GET"
            })
            .done(function(data) {
                if (data.code == 0) {
                    let dat = data.msg;
                    $(self).addClass(secondClass);
                    $(self).empty();
                    $(self).append($("<div class='rounded mb-0 border border-light d-flex justify-content-around  align-items-center' style='background-color: #3B707D'></div>").html(`<span>${dat.user}</span> <img src="./img/profile/${dat.pic}" class="rounded-circle z-depth-0" alt="avatar image" height="35">`));
                }
            });
    });
}