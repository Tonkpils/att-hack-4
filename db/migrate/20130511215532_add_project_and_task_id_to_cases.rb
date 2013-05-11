class AddProjectAndTaskIdToCases < ActiveRecord::Migration
  def change
    add_column :cases, :project_id, :integer
    add_column :cases, :task_id, :integer
  end
end
