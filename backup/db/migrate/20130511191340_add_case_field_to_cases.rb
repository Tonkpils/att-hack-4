class AddCaseFieldToCases < ActiveRecord::Migration
  def change
    add_column :cases, :name, :string
    add_column :cases, :user_id, :integer
  end
end
