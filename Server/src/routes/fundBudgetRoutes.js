const express = require("express");
const fundBudgetController = require("../controllers/fundBudgetController");
const protect = require("../middleware/authMiddleware");
const { checkModuleAccess } = require("../middleware/moduleAccessMiddleware");

const router = express.Router();

// Protect all routes
router.use(protect);
router.use(checkModuleAccess("projects"));

router
  .route("/")
  .get(
    fundBudgetController.getAllFundBudgets
  )
  .post(
    fundBudgetController.createFundBudget
  );

router
  .route("/:id")
  .get(
    fundBudgetController.getFundBudget
  )
  .put(
    fundBudgetController.updateFundBudget
  )
  .delete(
    fundBudgetController.deleteFundBudget
  );

module.exports = router;
