function fnAttachOption($selectElement, $to, inputName){
    option_val = $selectElement.val();
    
    if (option_val == 0) {
        return false;
    }

    $selectedOption = $selectElement.find(`option[value='${option_val}']`);

    $attachingBlock = $(`
    <h4 class="m-1 attaching-block">
        <span class="badge badge-pill badge-primary">
            <span class="selected-option-name">${$selectedOption.text()}</span>
            <span class="rounded-circle bg-light text-dark px-1 ml-2 detach-option-btn" aria-hidden="true" style="cursor: pointer;">&times;
            </span>
        </span>
        <input type="text" name="${inputName}[]" value="${option_val}" class="attaching-option-hidden" hidden>
    </h4>
    `);

    $attachingBlock.find('.detach-option-btn').bind('click', function() {
        fnDetachOption($(this), `select-${inputName}`);
    });
    
    $to.append($attachingBlock);

    $selectedOption.detach();
}

function fnDetachOption($el, $selectElementId){
    $selectElement = $(`#${$selectElementId}`);

    $detachingBlock = $el.parents('.attaching-block');

    permission_id = $detachingBlock.find('.attaching-option-hidden').attr('value');
    permission_text = $el.parent().find('.selected-option-name').text();

    $detachingBlock.detach();

    $selectElement.append(`
    <option 
    value="${permission_id}"
    >${permission_text}</option>
    `);
}