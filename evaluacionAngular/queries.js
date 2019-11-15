const Pool = require('pg').Pool
const pool = new Pool({
  user: 'root',
  host: 'localhost',
  database: 'test',
  password: 'root',
  port: 5432,
})

const getItems = (req, res) => {
  pool.query('SELECT * FROM motivos_es_gt ORDER BY motivo ASC', (error, results) => {
    if (error) {
      throw error
    }
    res.status(200).json(results.rows)
  })
}

const getItemById = (req, res) => {
  const id = parseInt(req.params.id)
  pool.query('SELECT * FROM motivos_es_gt WHERE motivo = $1', [id], (error, results) => {
    if (error) {
      throw error
    }
    res.status(200).json(results.rows)
  })
}

const createItem = (req, res) => {
  const { des_motivo, estado, tipo } = req.body
  
  pool.query('INSERT INTO motivos_es_gt (des_motivo, estado, tipo) VALUES ($1, $2, $3)', [des_motivo, estado, tipo], (error, results) => {
    if (error) {
      throw error
    }
    res.status(201).send(`Item added with ID: ${results.insertId}`)
  })
}

const updateItem = (req, res) => {
  const id = parseInt(req.params.id)
  const { des_motivo, estado, tipo } = req.body
  pool.query(
    'UPDATE motivos_es_gt SET des_motivo = $1, estado = $2, tipo = $3 WHERE motivo = $4',
    [des_motivo, estado, tipo, id],
    (error, results) => {
      if (error) {
        throw error
      }
      res.status(200).send(`Item modified with ID: ${id}`)
    }
  )
}

const deleteItem = (req, res) => {
  const id = parseInt(req.params.id)
  pool.query('DELETE FROM motivos_es_gt WHERE motivo = $1', [id], (error, results) => {
    if (error) {
      throw error
    }
    res.status(200).send(`Item deleted with ID: ${id}`)
  })
}

module.exports = {
  getItems,
  getItemById,
  createItem,
  updateItem,
  deleteItem,
}
