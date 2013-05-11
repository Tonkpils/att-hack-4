class AddInvoiceIdToCases < ActiveRecord::Migration
  def change
    add_column :cases, :invoice_id, :integer
  end
end
