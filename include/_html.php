<div class="RoomBookingSystem">
    <input type="hidden" id="RBS-URL" value="<?php echo $this->RBS_URL; ?>"/>

    <?php if ($this->RBS_URL == "") : ?>

        <div class="px-4 py-3 leading-normal border border-red-700 text-red-700 bg-red-100 rounded-lg">
            <strong>Error:</strong> Room Booking System URL has not been set. Please contact your system administrator.
        </div>

    <?php else : ?>

        <div class="flex flex-row">
            <div class="RBS-location flex-1 px-2">
                <select name="room" id="room" class="input-field">
                    <option value="">Select Room</option>
                    <?php foreach ($this->settings['rooms'] as $i => $room) : ?>
                        <option value="<?php echo $room['code']; ?>" rel="<?php echo $room['resourceID']; ?>">
                            <?php echo $room['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex-1 px-2 flex flex-row">
                <span class="bg-gray-500 p-2 text-white" id="RBS-date-lbl">Please Select a Date:</span>
                <?php if ($this->edit) : ?>
                    <input type="text" class="input-field bg-gray-400 flex-1" disabled="disabled" id="RBS-date" value="<?php echo date('d/m/Y'); ?>"/>
                <?php else : ?>
                    <input type="text" class="input-field flex-1" id="RBS-date" />
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 mt-2">
            <iframe name="iframe" id="calFrame" width="100%" height="990" frameborder="0" scrolling="yes"></iframe>
        </div>

    <?php endif; ?>

</div>