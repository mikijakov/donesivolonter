    window.onload = function() {

        // If sessionStorage is storing default values (ex. name), exit the function and do not restore data
        /* if (sessionStorage.getItem('name') == "name") {
            return;
        } */

        // If values are not blank, restore them to the fields
        var address = sessionStorage.getItem('address');
        if (address !== null) $('#address-delivery').val(address);

        var selectType = sessionStorage.getItem('selectType');
        if (selectType !== null) $('#select-type').val(selectType);

        var deliveryDetails = sessionStorage.getItem('deliveryDetails');
        if (deliveryDetails !== null) $('#inputSubject').val(deliveryDetails);

        var isCheckedLoc = sessionStorage.getItem('checkedCurrentLocation');
        if (isCheckedLoc !== null) this.clickedLocatedSuccessful = isCheckedLoc;
    }

    window.onbeforeunload = function() {
        sessionStorage.setItem("address", $('#address-delivery').val());
        sessionStorage.setItem("selectType", $('#select-type').val());
        sessionStorage.setItem("deliveryDetails", $('#delivery-details').val());
        sessionStorage.setItem("checkedCurrentLocation", this.clickedLocatedSuccessful);
    }