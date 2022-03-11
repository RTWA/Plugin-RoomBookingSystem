<div class="RoomBookingSystem">
    <input type="hidden" id="RBS-URL" value="<?php echo $this->RBS_URL; ?>" />

    <?php if ($this->RBS_URL == "" || $this->RBS_URL === null) : ?>

        <div class="px-4 py-3 leading-normal border border-red-700 text-red-700 bg-red-100 rounded-lg">
            <strong>Error:</strong> Room Booking System URL has not been set. Please contact your system administrator.
        </div>

    <?php else : ?>

        <div class="flex flex-row">
            <div class="RBS-location flex-1 px-2">
                <select name="room" id="room" class="bg-gray-50 border-2 border-gray-300 text-gray-900 outline-none text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-colors focus:ring-<?php echo $this->theme; ?>-600 dark:focus:ring-<?php echo $this->theme; ?>-500 focus:border-<?php echo $this->theme; ?>-600 dark:focus:border-<?php echo $this->theme; ?>-500">
                    <option value="">Select Room</option>
                    <?php foreach ($this->settings['rooms'] as $i => $room) : ?>
                        <option value="<?php echo $room['code']; ?>" rel="<?php echo $room['resourceID']; ?>">
                            <?php echo $room['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex-1 px-2 flex flex-row">
                <label for="RBS-date" id="RBS-date-lbl" class="inline-flex items-center px-3 text-xs text-gray-900 bg-gray-200 rounded-tl-lg rounded-bl-lg border-2 border-r-1 border-gray-300 dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                    Please Select a Date:
                </label>
                <?php if ($this->edit) : ?>
                    <input type="text" disabled="disabled" id="RBS-date" value="<?php echo date('d/m/Y'); ?>" class="flex-1 bg-gray-50 border-2 border-l-0 border-gray-300 text-gray-900 outline-none text-sm rounded-tr-lg rounded-br-lg block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-colors focus:ring-<?php echo $this->theme; ?>-600 dark:focus:ring-<?php echo $this->theme; ?>-500 focus:border-<?php echo $this->theme; ?>-600 dark:focus:border-<?php echo $this->theme; ?>-500" />
                <?php else : ?>
                    <input type="text" id="RBS-date" class="flex-1 bg-gray-50 border-2 border-l-0 border-gray-300 text-gray-900 outline-none text-sm rounded-tr-lg rounded-br-lg block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white transition-colors focus:ring-<?php echo $this->theme; ?>-600 dark:focus:ring-<?php echo $this->theme; ?>-500 focus:border-<?php echo $this->theme; ?>-600 dark:focus:border-<?php echo $this->theme; ?>-500" />
                <?php endif; ?>
            </div>
        </div>

        <div class="col-12 mt-2">
            <iframe name="iframe" id="calFrame" width="100%" height="990" frameborder="0" scrolling="yes"></iframe>
        </div>

    <?php endif; ?>

</div>

<div class="RoomBookingSystem-Preview h-24 flex items-center">
    <div class="flex flex-col text-center w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>You cannot preview this Block!</p>
    </div>
</div>