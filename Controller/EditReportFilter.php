<?php
/**
 * This file is part of Informes plugin for FacturaScripts
 * Copyright (C) 2022-2023 Carlos Garcia Gomez <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace FacturaScripts\Plugins\Informes\Controller;

use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

/**
 * @author Daniel Fernández Giménez <hola@danielfg.es>
 */
class EditReportFilter extends EditController
{
    public function getLines(): array
    {
        $model = $this->getModel();
        return $model->getLines();
    }

    public function getModelClassName(): string
    {
        return 'ReportFilter';
    }

    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['menu'] = 'reports';
        $data['title'] = 'reports-filter';
        $data['icon'] = 'fas fa-chalkfilter';
        return $data;
    }

    protected function createViews()
    {
        parent::createViews();
        $this->setTabsPosition('bottom');

        // desactivamos el botón de imprimir
        $this->setSettings($this->getMainViewName(), 'btnPrint', false);

        // añadimos las pestañas
        $this->createViewsLines();
    }

    protected function createViewsLines(string $viewName = 'EditReportFilterLine'): void
    {
        $this->addEditListView($viewName, 'ReportFilterLine', 'filters', 'fas fa-chart-pie');

        // ponemos la vista compacta
        $this->views[$viewName]->setInLine(true);
    }

    protected function loadData($viewName, $view)
    {
        $mvn = $this->getMainViewName();
        switch ($viewName) {
            case 'EditReportFilterLine':
                $code = $this->getViewModelValue($mvn, 'id');
                $where = [new DataBaseWhere('idreportfilter', $code)];
                $orderBy = [];
                $view->loadData('', $where, $orderBy);
                break;

            default:
                parent::loadData($viewName, $view);
                break;
        }
    }
}
