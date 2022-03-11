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

    public $theme;

    public $RBS_URL;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $plugin = json_decode(file_get_contents(__DIR__ . '/plugin.json'), true);
        $this->name = $plugin['name'];
        $this->icon = $plugin['icon'];
        $this->version = $plugin['version'];
        $this->author = $plugin['author'];

        $this->theme = ApplicationSettings::get('core.ui.theme');

        $this->RBS_URL = ApplicationSettings::get('plugin.RoomBookingSystem.url');
        $this->preview['rooms']['each'] = '<iframe name="iframe" id="calFrame{index-1}" width="100%" height="990" 
                                                frameborder="0" scrolling="yes" class="calFrame"
                                                src="' . $this->RBS_URL . '/digitalsignage?code={value.code}&resourceId={value.resourceID}&date=' . date('d/M/Y') . '"></iframe>';

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
        'repeater' => "var frames = document.getElementsByClassName('calFrame');
                        var i;
                        for (i=0;i<frames.length;i++) {
                            frames[i].classList.add('hidden');
                        }
                        var frame = document.getElementById('calFrame'+repeater);
                        if (frame) {
                            frame.classList.remove('hidden');
                        }",
    ];

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
        return file_get_contents(__DIR__ . '/include/_style.css');
    }

    public function scripts($edit = false)
    {
        if ($edit) {
            return '';
        } else {
            return file_get_contents(__DIR__ . '/include/_rbs.js');
        }
    }
}
