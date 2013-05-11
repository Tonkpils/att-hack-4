class AddInvoiceNumberToCases < ActiveRecord::Migration
  def change
    add_column :cases, :invoice_number, :integer
  end
end
