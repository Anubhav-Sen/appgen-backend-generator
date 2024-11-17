"""refactored the user model into multiple models to make data validation simple

Revision ID: abb598683bcf
Revises: d3fab35181b6
Create Date: 2024-11-17 09:57:19.463158

"""
from typing import Sequence, Union

from alembic import op
import sqlalchemy as sa
import sqlmodel


# revision identifiers, used by Alembic.
revision: str = 'abb598683bcf'
down_revision: Union[str, None] = 'd3fab35181b6'
branch_labels: Union[str, Sequence[str], None] = None
depends_on: Union[str, Sequence[str], None] = None


def upgrade() -> None:
    pass


def downgrade() -> None:
    pass
