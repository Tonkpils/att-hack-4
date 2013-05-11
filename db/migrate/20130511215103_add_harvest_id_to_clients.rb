class AddHarvestIdToClients < ActiveRecord::Migration
  def change
    add_column :clients, :harvest_id, :integer
  end
end
