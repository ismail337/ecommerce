<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellerPendingProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $editBtn = "<a href='" . route('admin.product.edit', $query->id) . "' class='btn btn-primary'><i class='far fa-edit'></i></a>";

                $deleteBtn = "<a href='" . route('admin.product.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='far fa-trash-alt'></i></a>";

                $moreBtn = '<div class="dropdown dropleft d-inline ml-2">
                      <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                      </button>
                      <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                        <a class="dropdown-item" href="' . route('admin.product-image-gallery.index', [ 'product' => $query->id ]) . '">Image Gallery</a>
                        <a class="dropdown-item" href="' . route('admin.product-variant.index', [ 'product' => $query->id ]) . '">Variant</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                      </div>
                    </div>';

                return $editBtn . $deleteBtn . $moreBtn;
            })
            ->addColumn('thumb_image', function ($query) {
                return $img = "<img width='100px' src='" . asset($query->thumb_image) . "'/>";
            })
            ->addColumn('type', function ($query) {
                if ($query->product_type == 'new_arrival') {
                    $bagde = '<span class="badge badge-primary">New Arrival</span>';
                } elseif ($query->product_type == 'best_product') {
                    $bagde = '<span class="badge badge-success">Best Seller</span>';
                } elseif ($query->product_type == 'featured_product') {
                    $bagde = '<span class="badge badge-warning">Featured Product</span>';
                } elseif ($query->product_type == 'top_product') {
                    $bagde = '<span class="badge badge-danger">Top Product</span>';
                } else {
                    $bagde = '<span class="badge badge-info">General Product</span>';

                }

                return $bagde;
            })
            ->addColumn('status', function ($query) {
                if ($query->status == 1) {
                    $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" checked name="custom-switch-checkbox" class="custom-switch-input change-status" data-id="' . $query->id . '">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"></span>
                      </label>';
                } else {
                    $button = '<label class="custom-switch mt-2">
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input change-status" data-id="' . $query->id . '">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description"></span>
                      </label>';
                }

                return $button;
            })
            ->addColumn('approve', function ($query) {
                return "<select class='form-control is_approve' data-id='$query->id'>
            <option " . ($query->is_approved == 0 ? 'selected' : '') . " value='0'>Pending</option>
            <option " . ($query->is_approved == 1 ? 'selected' : '') . " value='1'>Approved</option>
            </select>";
            })
            ->addColumn('brand', function ($query) {
                return $query->brand->name ?? '';
            })
            ->addColumn('category', function ($query) {
                return $query->category->name ?? '';
            })
            ->rawColumns([ 'action', 'status', 'thumb_image', 'type', 'approve' ])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('is_approved', 0)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('sellerpendingproduct-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('thumb_image')->title('Image')->width(120),
            Column::make('name'),
            Column::make('price'),
            Column::make('brand')->title('Brand'),
            Column::make('category')->title('Category'),
            Column::make('type')->width(150),
            Column::computed('status')->width(100)->exportable(false)->printable(false),
            Column::make('approve')->width(200),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'SellerPendingProduct_' . date('YmdHis');
    }
}
