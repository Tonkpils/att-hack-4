class CreateCases < ActiveRecord::Migration
  def change
    create_table :cases do |t|
      t.integer :client_id
      t.text :notes

      t.timestamps
    end
  end
end
