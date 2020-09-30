<?php

namespace ESGI\Controllers;

use ESGI\Core\Auth\Auth;
use ESGI\Core\Database\Pagination;
use ESGI\Core\Database\QueryBuilder;
use ESGI\Models\AnnouncementsModel;
use ESGI\Models\BatchesModel;
use ESGI\Models\EventsModel;
use ESGI\Models\GroupsModel;
use ESGI\Models\OwnersModel;
use ESGI\Models\PagesModel;
use ESGI\Models\PropertiesModel;
use ESGI\Models\StaffModel;
use ESGI\Models\UsersModel;
use ESGI\Models\ReportsModel;

class AdministrationController extends Controller
{
    public $security = ['searchAction' => 'administration.search'];

    public function indexAction(): void
    {
        if (Auth::getUser()->getGroup() === null) {
            $this->publicIndexAction();
            return;
        }

        // We are only taking up coming events
        /** @var EventsModel[] $events */
        $events = EventsModel::fetchAll(
            (new QueryBuilder)
                ->where('date_start', '>', date('y-m-d'))
                ->where('type', '=', 1)
                ->limit(10)
        );

        // Reported announcements
        /** @var ReportsModel[] $reports */
        $reports = ReportsModel::fetchAll(
            (new QueryBuilder)
                ->join(AnnouncementsModel::getTableName(), 'announcement_id')
                ->orderRaw('reports.created_at DESC')
                ->limit(10)
        );

        // Taking announcements that are pending validation => validation mechanism will be added next
        /** @var AnnouncementsModel[] $announcements */
        $announcements = AnnouncementsModel::fetchAll(
            (new QueryBuilder)
                ->where('status', '=', 0)
                ->limit(10)
        );

        $statistics = [
            'Annonces' => AnnouncementsModel::count(),
            'Lots' => BatchesModel::count(),
            'Propriétés' => PropertiesModel::count(),
            'Propriétaires' => OwnersModel::count(),
        ];

        $this->render('administration.index', 'backend', [
            'events' => $events,
            'reports' => $reports,
            'announcements' => $announcements,
            'statistics' => $statistics
        ]);
    }

    public function publicIndexAction(): void
    {
        /** @var UsersModel $user */
        $user = Auth::getUser();

        // Properties
        $queryBuilder = (new QueryBuilder)
            ->where('user_id', '=', $user->getId())
            ->order('id', 'desc');

        $queryBuilder = Pagination::getQuery(PropertiesModel::getTableName(), null, $queryBuilder);
        $properties = PropertiesModel::fetchAll($queryBuilder);

        // Batches
        $queryBuilder = (new QueryBuilder)
            ->join(PropertiesModel::getTableName(), 'property_id')
            ->whereRaw('properties.user_id = ' . $user->getId())
            ->order('number', 'asc');

        $queryBuilder = Pagination::getQuery(BatchesModel::getTableName(), null, $queryBuilder);
        $batches = BatchesModel::fetchAll($queryBuilder);

        // Announcements
        $queryBuilder = (new QueryBuilder)
            ->join(BatchesModel::getTableName(), 'batch_id')
            ->join(PropertiesModel::getTableName(), 'property_id', 'id', '=', 'left', 'batches')
            ->whereRaw('announcements.user_id = ' . $user->getId())
            ->order('created_at', 'desc');

        $queryBuilder = Pagination::getQuery(AnnouncementsModel::getTableName(), null, $queryBuilder);
        $announcements = AnnouncementsModel::fetchAll($queryBuilder);

        $this->render('administration.public_index', 'backend', [
            'properties' => $properties,
            'batches' => $batches,
            'announcements' => $announcements
        ]);
    }

    public function searchAction(): void
    {
        $search = addslashes(htmlentities($_GET['search'] ?? ''));

        // Models
        $announcements = AnnouncementsModel::search($search);
        $events = EventsModel::search($search);
        $groups = GroupsModel::search($search);
        $staff = StaffModel::search($search);
        $properties = PropertiesModel::search($search);
        $owners = OwnersModel::search($search);
        $pages = PagesModel::search($search);
        $users = UsersModel::search($search);

        $this->render('administration.search', 'backend', [
            'search' => $search,
            'count' => count($announcements) + count($events) + count($groups) + count($staff) + count($properties) + count($owners) + count($pages) + count($users),
            'announcements' => $announcements,
            'events' => $events,
            'groups' => $groups,
            'staff' => $staff,
            'properties' => $properties,
            'owners' => $owners,
            'pages' => $pages,
            'users' => $users
        ]);
    }
}
