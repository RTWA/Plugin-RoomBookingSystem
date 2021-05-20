<?php

namespace WebApps\Plugin;

use App\Models\Plugin;
use RobTrehy\LaravelApplicationSettings\ApplicationSettings;

class RoomBookingSystem_Plugin extends Plugin
{
    public $name;
    public $icon;
    public $version;
    public $author;

    public $RBS_URL;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $plugin = json_decode(file_get_contents(__DIR__ . '/plugin.json'), true);
        $this->name = $plugin['name'];
        $this->icon = $plugin['icon'];
        $this->version = $plugin['version'];
        $this->author = $plugin['author'];

        $this->RBS_URL = ApplicationSettings::get('plugin.RoomBookingSystem.url');
        $this->preview['rooms']['each'] = '<iframe name="iframe" id="calFrame{index-1}" width="100%" height="990" 
                                                frameborder="0" scrolling="yes" class="calFrame"
                                                src="'.$this->RBS_URL.'/digitalsignage?code={value.code}&resourceId={value.resourceID}&date='.date('d/M/Y').'"></iframe>';

        if ($this->RBS_URL === '' || $this->RBS_URL === null) {
            $this->preview['rooms']['each'] = '<div class="px-4 py-3 leading-normal border border-red-700 text-red-700 bg-red-100 rounded-lg"><strong>ERROR:</strong> Room Booking System URL is not set. Please contact your System Administrator.</div>';
        }
    }

    public $options = [
        'rooms' => [
            'type' => 'repeater',
            'label' => 'Room',
            'ref' => 'name',
            'options' => [
                'name' => [
                    'type' => 'text',
                    'label' => 'Enter the name of the room',
                    'maxLength' => 255,
                    'required' => true,
                ],
                'code' => [
                    'type' => 'text',
                    'label' => 'Enter the code portion of the URL',
                    'maxLength' => 50,
                    'required' => false,
                ],
                'resourceID' => [
                    'type' => 'text',
                    'label' => 'Enter the ResourceID portion of the URL',
                    'maxLength' => 20,
                    'required' => false,
                ],
            ]
        ]
    ];

    public $new = [
        'rooms' => [['name' => '', 'code' => '', 'resourceID' => '']]
    ];

    public $preview = [
        'rooms' => [
            'each' => '',
        ],
        'repeater' => "$('.calFrame').hide(); $('#calFrame'+repeater).show();",
        'blockPreview' => '',
    ];

    public function prepare($data)
    {
        parent::prepare($data);

        $this->preview['blockPreview'] = "$('#".$this->publicId." .col-6').hide(); $('#".$this->publicId." #calFrame').attr('src', '".$this->RBS_URL."/digitalsignage?code=".$this->settings['rooms'][0]['code']."&resourceId=".$this->settings['rooms'][0]['resourceID']."&date=".date('d/M/Y')."');"
                                        ."$('#block-preview .RoomBookingSystem .col-6').hide();$('#block-preview .RoomBookingSystem #calFrame').attr('src', '".$this->RBS_URL."/digitalsignage?code=".$this->settings['rooms'][0]['code']."&resourceId=".$this->settings['rooms'][0]['resourceID']."&date=".date('d/M/Y')."');";

        return $this;
    }

    public function output($edit = false)
    {
        $this->edit = $edit;
        ob_start();
        require('include/_html.php');
        $html = str_replace(["\r", "\n", "\t"], '', trim(ob_get_clean()));
        $html = preg_replace('/(\s){2,}/s', '', $html);
        return $html;
    }

    public function style()
    {
        return file_get_contents(__DIR__.'/include/_style.css');
    }

    public function scripts($edit = false)
    {
        if ($edit) {
            return '';
        } else {
            return file_get_contents(__DIR__.'/include/_rbs.js');
        }
    }
}
