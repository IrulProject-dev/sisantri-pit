<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navigation extends Component
{
    public function render()
    {
        return view('components.navigation', [
            'items' => $this->getNavigationItems(),
        ]);
    }

    protected function isGroupActive($group)
    {
        foreach ($group['children'] ?? [] as $child) {
            if (request()->routeIs($child['route'] . '*')) {
                return true;
            }
        }
        return false;
    }

    public function getNavigationItems()
    {
        return [
            [
                'name'  => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'Jurusan',
                'route' => 'divisions.index',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'Angkatan',
                'route' => 'batches.index',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'Santri',
                'route' => 'santris.index',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'Sesi Absensi',
                'route' => 'attendance-sessions.index',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'Absensi',
                'route' => 'attendances.index',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                'is_group' => false,
            ],
            [
                'name'  => 'assesment',
                'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                'is_group' => true,
                'children' => [
                    [
                        'name'  => 'Komponen Penilaian',
                        'route' => 'assessment-components.index',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
                    ],
                    [
                        'name' => 'Template Penilaian',
                        'route' => 'assessment-templates.index',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0z"></path>',
                    ],
                    [
                        'name' => 'Periode Penilaian',
                        'route' => 'assessment-periods.index',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.5,3 L12.5,3 C13.3284271,3.00000001,14,3.67157288,14,4.5 L14,7 L10,7 L10,4.5 C10,3.67157288,10.6715729,3,11.5,3 Z M16,7 L16,4.5 C16,2.01471862,13.9852814,-1.42108547e-14,11.5,-1.42108547e-14 C9.01471862,-1.42108547e-14,7,-2.01471862e+00,7,-4.5 L7,-7 L17,-7
                C18.1045695,-7,19,7.8954305,19,9 L19,16 C19,17.1045695,18.1045695,18,17,18 L7,18 C5.8954305,18,5,17.1045695,5,16 L5,9 C5,7.8954305,5.8954305,7,7,7 L10,-4.4408921e-14 L10,-3.55271368e-15 C10,-1.42108547e-14,11.4210854,-1.42108547e-14,12.5,-1.42108547e-14 Z M17,-3 L17,-3 C18.1045695,-3,19,-2.1045695,19,-1 L19,-1 C19,-0.44771525,18.5522847,-1.42108547e-14,18,-1.42108547e-14 C17.4477153,-1.42108547e-14,17,-0.44771525,17,-1 Z M17,-3 L17,-3 Z"></path>',
                    ],
                    [
                        'name'  => 'kategori Penilaian',
                        'route' => 'assessment-categories.index',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0z"></path>',
                    ],
                    [
                        'name'  => 'target Penilaian',
                        'route' => 'assessment-targets.index',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0z"></path>',
                    ],
                    [
                        'name'  => 'Penilaian',
                        'route' => 'assessments.index',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0z"></path>',
                    ],
                    [
                        'name'  => 'rapot',
                        'route' => 'report.index',
                        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0z"></path>',
                    ]
                ]
            ]

        ];
    }
}
